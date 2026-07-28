# Backup Impoort Feature

I have created this before. I want you to duplicate what i've wrote into this laravel project. There may are some differences between my codes due to different timeline and experience, and you should implement the coding style i use in this project.

Old project location you should look inside :
```
~/gabut/ppdb
```

Take a look at `admin.settings.backup` and `admin.restore` routes (`~/gabut/ppdb/routes/web.php`) to learn what i have wrote previously, learn how i get the data, archive them, and restore back the data to the database.

And I just realized there may occure an error about the relationship, so this time you may have to ignore the foreign key checks before backing up and restoring the data.

I want you to put this page into the "Pengaturan" sub menu just as in my previous project.

Do not improve that not causing crash in flow, by this mean, ignore security issues or any bad experience, the most important thing is this feature is working fine first.