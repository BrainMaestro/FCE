with open('fCE Sample Spreadsheet (1).csv', 'r') as file:
    # read a list of lines into data
    data = file.readlines()

# now change the 2nd line, note that you have to add a newline
i = 0
while(i < len(data)):
	data[i] = data[i].replace('\n','') + ',' + 'Spring 2014\n'
	i = i+1

# and write everything back
with open('fCE Sample Spreadsheet (1).csv', 'w') as file:
    file.writelines( data )
