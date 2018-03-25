#!/bin/bash
/usr/local/bin/wkhtmltopdf --encoding UTF-8 --footer-html ${1}plans/footer/${2}?demo_user=yes ${1}plans/${3}/${2}?demo_user=yes assets/downloads/${3}_${2}.pdf
