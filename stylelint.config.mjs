/** @type {import('stylelint').Config} */
export default {
  extends: ['stylelint-config-standard'],
  plugins: ['stylelint-prettier'],
  rules: {
    'prettier/prettier': true,
    'no-descending-specificity': null,
    'property-no-vendor-prefix': null,
    'import-notation': 'string',
  },
}
