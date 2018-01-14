#!/bin/sh

SESSION_ID=evpauqzdpakancrujp24e2ju

curl https://indx.ru/TradingStats.asmx/GetDealsLast \
     --compressed \
     --header "User-Agent: Mozilla/5.0 (X11; FreeBSD amd64; rv:57.0) Gecko/20100101 Firefox/57.0" \
     --header "Referer: https://indx.ru/trade/0/" \
     --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --data ""
