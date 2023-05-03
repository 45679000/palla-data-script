import json
import mysql.connector
from datetime import datetime


mydb = mysql.connector.connect(
  host="localhost",
  user="iano",
  password="Kovacic17?",
  database="ll"
)

mycursor = mydb.cursor()
# Open the file in read mode
with open('loan.json', 'r') as f:
    # Read the file in chunks of 100 MB
    while True:
        chunk = f.read(100 * 1024 * 1024) # Read 100 MB at a time
        if not chunk:
            break # End of file
        data = json.loads(chunk)
        
        # Process the data chunk here
        # For example, you could print the length of the data:
        dy = []
        for x in data['pageItems']:
            # or x['timeline']['submittedOnDate'][1] == 10
            # print(x['timeline']['submittedOnDate'][1] == 9 or x['timeline']['submittedOnDate'][1] == 10)
            if(x['timeline']['submittedOnDate'][1] == 9 ):
                # print(x)
                # print("\n\n\n")
                date_list = x['timeline']['submittedOnDate']
                date_start = datetime(date_list[0], date_list[1], date_list[2]).strftime('%d-%b-%Y')

                date_end = x['timeline']['expectedMaturityDate']
                date_exp = datetime(date_end[0], date_end[1], date_end[2]).strftime('%d-%b-%Y')
                # print(date_start)
                # print("\n")
                # print(date_exp)

                sql = "INSERT INTO loans (client_id, loan_Id,client,loan_amount,loan_date,exp_date) VALUES (%s, %s, %s, %s, %s, %s)"
                val = (x['clientId'],x['id'],x['clientName'],x['principal'],date_start,date_exp)
                mycursor.execute(sql, val)

                mydb.commit()

                print(mycursor.rowcount, "record inserted.")

                # dy.append(x)

        # print(dy)
        # print(data['pageItems'][100]['timeline']['submittedOnDate'][1])
