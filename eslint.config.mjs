import { defineConfig } from 'eslint/config'
import globals from 'globals'
import js from '@eslint/js'
import pluginPrettierRecommended from 'eslint-plugin-prettier/recommended'

export default defineConfig([
  { ignores: ['public/build/', 'public/assets/', 'vendor/', 'var/'] },
  { languageOptions: { globals: { ...globals.browser, ...globals.node } } },
  { plugins: { js }, extends: ['js/recommended'] },
  pluginPrettierRecommended,
])
