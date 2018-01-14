#!/bin/sh

curl --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://indx.ru/trade/0/" \
     --data "{symbolid:67,fullqueue:false}" \
     https://indx.ru/TradingStats.asmx/GetOffers