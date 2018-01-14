#!/bin/sh

SESSION_ID=hkncussj5i35ssdje5damy3h

curl https://indx.ru/TradingStats.asmx/GetDealsHistory \
     --compressed \
     --header "User-Agent: Mozilla/5.0 (X11; FreeBSD amd64; rv:57.0) Gecko/20100101 Firefox/57.0" \
     --header "Referer: https://indx.ru/deals/" \
     --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --header "Connection: keep-alive" \
     --header "Cookie: ASP.NET_SessionId=${SESSION_ID}" \
     --data "{\"only\":0,\"symbolID\":0,\"page\":1,\"size\":5,\"field\":8,\"orderby\":1,\"start\":\"13.01.2018\",\"end\":\"14.01.2018\"}"
