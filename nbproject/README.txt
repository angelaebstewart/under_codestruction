project.properties
Line 21: 
test.src.dir=../../../../Applications/MAMP/htdocs/under_codestruction

You may or may not need this line. If you choose to delete this line edit the next line:
test.src.dir2=${file.reference.Tests-model}
 to be
test.src.dir=${file.reference.Tests-model}

Also, rename the two files:
project.properties.txt
project.xml.txt

So that the .txt will be removed. Place these files in the nbproject folder, where you have the project located on your file system.

After this is done, if you have had netbeans open, then restart netbeans. It should work. May the force be with you...