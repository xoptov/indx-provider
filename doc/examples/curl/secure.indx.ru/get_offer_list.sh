#!/bin/sh

# Запрос на получение списка заявок по нотам. Можно указать несколько типов нот по которых получится ответ.

curl --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://secure.indx.ru/Portfolio.aspx" \
     --data "{requests:[{SymbolID:67,Selector:\"#queue67\",FullQueue:false},{SymbolID:37,Selector:\"queue37\",FullQueue:false}],maxCount:1}" \
     https://secure.indx.ru/TradingStats.asmx/GetOfferLists
