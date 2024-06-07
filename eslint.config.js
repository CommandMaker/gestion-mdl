import globals from 'globals';
import pluginJs from '@eslint/js';
import tseslint from 'typescript-eslint';
import pluginVue from 'eslint-plugin-vue';
import eslintConfigPrettier from 'eslint-config-prettier';

export default [
    {
        languageOptions: {
            globals: globals.browser,
            parserOptions: {
                ecmaVersion: 'latest',
                parser: '@typescript-eslint/parser',
                sourceType: 'module'
            }
        },
        rules: {
            indent: ['error', 4],
            'linebreak-style': ['error', 'unix'],
            quotes: ['error', 'single'],
            semi: ['error', 'always'],
            'arrow-parens': ['error', 'as-needed'],
            '@typescript-eslint/consistent-type-imports': 'error'
        },
        settings: {
            'import/resolver': {
                alias: {
                    '~': './resources/js'
                }
            }
        }
    },
    pluginJs.configs.recommended,
    ...tseslint.configs.recommended,
    ...pluginVue.configs['flat/essential'],
    eslintConfigPrettier
];
