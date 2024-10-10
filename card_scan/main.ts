import { SerialPort } from 'serialport';
import path from 'path';
import sqlite3 from 'sqlite3';
import { WebSocketServer } from 'ws';

if (process.argv.length < 3) {
    throw new Error('You must provide the serial port to use');
}

const portPath = process.argv[2];
const port = new SerialPort({ path: portPath, baudRate: 9600 });

port.on('open', () => {
    console.log(`Opened serial port on path "${port.path}"`);
});

const dbPath = path.join(process.cwd(), '../server/var/data.db');
const db = new sqlite3.Database(dbPath);

interface TimePeriod {
    id: number;
    start_time: string;
    end_time: string;
}

function getTimePeriods(): Promise<TimePeriod[]> {
    return new Promise((resolve, reject) => {
        db.all('SELECT * FROM time_period', (err, rows) => {
            if (err) reject(err);
            // @ts-ignore
            resolve(rows);
        });
    });
}

function getCurrentTimePeriod(timePeriods: TimePeriod[]): number {
    const currentDate = new Date();
    const currentTime = currentDate.getTime();

    for (const period of timePeriods) {
        const sStart = period.start_time.split(':');
        const sEnd = period.end_time.split(':');
        const start = new Date().setHours(+sStart[0], +sStart[1], +sStart[2]);
        const end = new Date().setHours(+sEnd[0], +sEnd[1], +sEnd[2]);

        if (currentTime >= start && currentTime <= end) {
            return period.id;
        }
    }

    return 1;
}

async function main(): Promise<void> {
    const timePeriods = await getTimePeriods();

    const server = new WebSocketServer({
        port: 8080
    });

    server.on('connection', connection => {
        const callback = async (data: any): Promise<void> => {
            const cardData = data.toString('utf-8').replace('\r', '');
            const timePeriod = getCurrentTimePeriod(timePeriods);

            const payload = {
                date: new Date().toISOString(),
                timePeriod: `/api/time_periods/${timePeriod}`,
                code: cardData
            };

            try {
                const response = await fetch(
                    'http://localhost:8000/api/card_scans',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/ld+json'
                        },
                        body: JSON.stringify(payload)
                    }
                );

                if (!response.ok) {
                    throw new Error(`Error: ${response.statusText}`);
                }

                connection.send(JSON.stringify(await response.json()));
            } catch (error) {
                console.error('Error sending data:', error);
            }
        };
        port.on('data', callback);

        connection.on('close', () => {
            port.removeListener('data', callback);
        });
    });
}

main().catch(error => console.error('Error:', error));
