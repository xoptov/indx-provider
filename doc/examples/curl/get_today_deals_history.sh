#!/bin/sh

# В этот раз необходимо указывать сессию для запроса.
SESSION_ID=4zhqxd4s2qqsvssbsqsj0uai

curl --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://secure.indx.ru/History.aspx" \
     --cookie "ASP.NET_SessionId=${SESSION_ID}" \
     --data "{symbolID:67,page:1,size:100,field:8,orderby:1}" \
     https://secure.indx.ru/TradingStats.asmx/GetTodayDealsHistory
