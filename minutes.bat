@echo off 
start http://localhost/niuframework/wap/event/
ping -n 5 127.1 >nul 5>nul 
taskkill /f /im IEXPLORE.exe 
exit