#!/bin/sh

curl https://indx.ru/TradingStats.asmx/GetLargeTradingStats \
     --compressed \
     -H "User-Agent: Mozilla/5.0 (X11; FreeBSD amd64; rv:57.0) Gecko/20100101 Firefox/57.0" \
     -H "Referer: https://indx.ru/statistics/" \
     -H "X-Requested-With: XMLHttpRequest" \
     -H "Content-Type: application/json" \
     --data ""
