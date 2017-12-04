
import os
import shutil
import errno


def copy(src, dest):
    try:
        shutil.copytree(src, dest)
    except OSError as e:
        # If the error was caused because the source wasn't a directory
        if e.errno == errno.ENOTDIR:
            shutil.copy(src, dest)
        else:
            print('Directory not copied. Error: %s' % e)



php_wd = '/Users/ExSidius/.bitnami/stackman/machines/xampp/volumes/root/htdocs/'

folder_name = 'OfficeHoursScheduler'
directory = php_wd + folder_name

if os.path.exists(directory):
    shutil.rmtree(directory)

copy('./', directory)

