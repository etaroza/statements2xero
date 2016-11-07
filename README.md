# Statements 2 Xero
Tools to transform custom bank statements to Xero digestible format.

## PostFinance (Switzerland)
Export transactions in the CSV format and then run:

    php postfinance2xero.php -file exmples/postfinance_export_Transactions_20161106.csv

## Litas-Esis (Lithuania)

```litasesis2xero.php```

This converter is using ```ofxstatement``` Python converter, so you have to install it first (https://github.com/kedder/ofxstatement).
 
My configuration of __ofxstatement edit-config__ is :

    [paysera:visa:eur]
    plugin = litas-esis
    charset = cp1257
    currency = EUR
    account = LT353500010001111111

I export transactions in the LITAS-ESIS format (file with _.acc_ extension) from PaySera. And then it's all easy:

    php litasesis2xero.php -config paysera:visa:eur -file exmples/litas-esis_2016-10-01_2016-10-31.acc


