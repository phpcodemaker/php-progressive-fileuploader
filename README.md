## php-progressive-fileuploader
PHP simple file uploader with Progress Bar

####Installation procedure

Generic installation through pecl repository

```pecl install uploadprogress```

Ubuntu

```apt install uploadprogress```

Change below details in php ini settings to upload bigger file
```
upload_max_filesize 2G #2GB
post_max_size 3G #3GB
```
Add below details in php.ini at the end of line

```
extension=uploadprogress.so
[uploadprogress]
uploadprogress.get_contents=On
uploadprogress.file.filename_template=/tmp/upt_%s.txt
uploadprogress.file.contents_template=/tmp/upload_contents_%s
```

Restart Apache2
```
sudo service apache2 restart
```

Restart nginx

```
sudo service nginx restart
```

Check the changes has been applied in php settings post server restart using phpinfo()
####uploadprogress
```

uploadprogress support	enabled
Version                 1.1.3
```

```
Directive	                            Local Value	                Master Value

uploadprogress.file.contents_template	/tmp/upload_contents_%s	    /tmp/upload_contents_%s
uploadprogress.file.filename_template	/tmp/upt_%s.txt	            /tmp/upt_%s.txt
uploadprogress.get_contents	            1	                        1

```

Prepare the HTML form as follows, do not change the variable name "UPLOAD_IDENTIFIER" also do not change the priority of form elements.
file input field should comes after UPLOAD_IDENTIFIER hidden field.
```
<form action="upload.php" method="POST" enctype="multipart/form-data" id="upload_form">
    <input type="hidden" name="UPLOAD_IDENTIFIER" id="UPLOAD_IDENTIFIER" value="<?php echo md5(uniqid(mt_rand())); ?>"/>
    <input type="file" name="uploaded_file"/>
    <!-- Any additional required form fields can be added below-->
    <input type="submit" value="Upload File"/>
</form>
```

Feel free to customize yourself anything...