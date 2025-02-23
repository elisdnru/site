import globals from 'globals'
import pluginJs from '@eslint/js'
import pluginPrettierRecommended from 'eslint-plugin-prettier/recommended'

/** @type {import('eslint').Linter.Config[]} */
export default [
  { ignores: ['public/build/', 'public/assets/', 'vendor/', 'var/'] },
  { files: ['**/*.{js,mjs}'] },
  { languageOptions: { globals: { ...globals.browser, ...globals.node } } },
  pluginJs.configs.recommended,
  pluginPrettierRecommended,
]
