# EmoMonitor---voce
Pentru functionare este necesar:
- MySQL
- XAMPP
- ffmpeg - suită de software open-source cu instrumente pentru manipulare fisiere audio
Se descarca de pe https://ffmpeg.org/download.html#build-windows
Fisierul descarcat cu software ul trebuie incarcat in User variable in Environmental Variables ale calculatorului.
- librarii python: librosa, numpy, tensorflow, mysql, pydub, sklearn, joblib

In fisierul upload.php trebuie:
- linia 8: modificare cu datele bazei de date pe care o creezi 
- linia 53 trebuie modicata calea din calculator catre fisierul .exe.

In fisierul apliare_algoritm.py:
- linia 25,72-77 - modificare cu datele bazei de date pe care o creezi 

In fisierul pag4.php:
- linia 63 - modificare cu datele bazei de date pe care o creezi
