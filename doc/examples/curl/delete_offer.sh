#!/bin/sh

# В этот раз необходимо указывать сессию для запроса.
SESSION_ID=4zhqxd4s2qqsvssbsqsj0uai

OFFER_ID=4577255

curl --header "X-Requested-With: XMLHttpRequest" \
     --header "Content-Type: application/json" \
     --user-agent "Mozilla/5.0 (X11; FreeBSD amd64; rv:56.0) Gecko/20100101 Firefox/56.0" \
     --referer "https://secure.indx.ru/Portfolio.aspx" \
     --cookie "ASP.NET_SessionId=${SESSION_ID}" \
     --data "{offerID:${OFFER_ID}}" \
     https://secure.indx.ru/Trading.asmx/DeleteOffer
