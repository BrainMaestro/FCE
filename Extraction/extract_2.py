import os
import xlrd
import csv

wb = xlrd.open_workbook("userTable.xlsx")
csvdata = []
data = {}
for sheet in wb.sheets():
    print "Sheet: " ,sheet.name
    for row in range(sheet.nrows):
        #email = str(sheet.cell(row,1).value)
        school = str(sheet.cell(row,2).value)
        name = str(sheet.cell(row,0).value)
        #data[name] = email
        data[name] = school
##data["(0 records)"] = "nullemail"
##data["Jennifer Che"] = "jennifer.che@aun.edu.ng"
##data["Reginald T Braggs"] = "reginald.braggs@aun.edu.ng"
##data["Jelena Zivkovic"] = "jelena.zivkovic@aun.edu.ng"
##data["Fidelis Ndeh-Che"] = "fidelis.ndehche@aun.edu.ng"
##data["Elke De Buhr"] = "elke.debuhr@aun.edu.ng"
##data["Lionel Rawlins"] = "lionel.rawlins@aun.edu.ng"

data["(0 records)"] = "nullschool"
data["Jennifer Che"] = "SAS"
data["Reginald T Braggs"] = "SAS"
data["Jelena Zivkovic"] = "SBE"
data["Fidelis Ndeh-Che"] = "SAS"
data["Elke De Buhr"] = "SAS"
data["Lionel Rawlins"] = "SAS"

wb2 = xlrd.open_workbook("SPRING 2015 COURSE SCHEDULE.xlsx")


##for sheetx in wb2.sheets():
##    print "Sheet: ", sheetx.name
##    for rrow in range(1,sheetx.nrows):
##        crn = str(int(sheetx.cell(rrow,3).value))
##        iname = str(sheetx.cell(rrow,4).value)
##        names = iname.split(", ")
##        
##        for item in names:
##            if data[item] != "nullemail":
##                csvdata.append([crn,data[item]])
##
##for sheetx in wb2.sheets():
##    print "Sheet: ", sheetx.name
##    for rrow in range(1,sheetx.nrows):
##        crn = str(int(sheetx.cell(rrow,3).value))
##        ccode = str(sheetx.cell(rrow,0).value)
##        sem = str(sheetx.cell(rrow,2).value)
##        iname = str(sheetx.cell(rrow,4).value)
##        names = iname.split(", ")
##        school = data[names[0]]
##        if school == "nullschool":
##            continue
##        ctitle = str(sheetx.cell(rrow,1).value)
##        ctime = str(sheetx.cell(rrow,5).value)
##        location = str(sheetx.cell(rrow,6).value)
##        locked = "1"
##        enrolled = str(sheetx.cell(rrow,7).value)
##        mid = "0"
##        final = "0"
##        #print crn,ccode,sem,school,ctitle,ctime,location,locked,enrolled,mid,final
##        csvdata.append([crn,ccode,sem,school,ctitle,ctime,location,locked,enrolled,mid,final])
##        
##        
##        
        
        
        

with open('test1.csv', 'w') as fp:
   a = csv.writer(fp, delimiter=',')
   a.writerows(csvdata)
print "Done!"
                           
        
            
                
