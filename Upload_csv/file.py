import mysql.connector
import pandas as pd

data = pd.read_csv("Upload_csv\IWP_.csv", header=None)
# for i in range(5):
#     print(data[i][0])
mydb = mysql.connector.connect(
    host="localhost",
    port="3307",
    user="root",
    password="",
    database="health_care"
)
mycursor = mydb.cursor()

sql = "INSERT INTO doctordetails (ID, Name, Pincode, Address, specialization) VALUES (%s, %s, %s, %s, %s)"

for i in range(1,len(data)):
    val = (str(data[0][i]), str(data[1][i]), str(data[2][i]), str(data[3][i]), str(data[4][i]))
    mycursor.execute(sql, val)

    mydb.commit()

print(mycursor.rowcount, "record inserted.")