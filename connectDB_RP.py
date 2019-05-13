import mysql.connector

mydb = mysql.connector.connect(
  host="localhost",
  user="u07580529",
  passwd="PwdDBIs07580529"
)

print(mydb)
