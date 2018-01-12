#!/bin/sh

curl --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://secure.indx.ru/Portfolio.aspx" \
     --data "{includeExpired:false,tradedOnly:true}" \
     https://secure.indx.ru/TradingStats.asmx/GetSymbolList
