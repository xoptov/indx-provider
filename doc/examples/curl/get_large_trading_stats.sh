#!/bin/sh

# Запрос на получение полного списка катировок.

curl --request POST \
     --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://secure.indx.ru/Statistics.aspx" \
     --data ""\
     https://secure.indx.ru/TradingStats.asmx/GetLargeTradingStats
