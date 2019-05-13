import pysftp

myHostname = "sftp://pilot.cp.su.ac.th"
myUsername = "u07580529"
myPassword = "Ff012426484"

import pysftp
sftp = pysftp.Connection("pilot.cp.su.ac.th", "u07580529", "Ff012426484")
#
# ... do sftp operations
#
sftp.close()
# with pysftp.Connection(host=myHostname, username=myUsername, password=myPassword) as sftp:
#     print("Connection succesfully stablished ... ")

    # Define the file that you want to upload from your local directorty
    # or absolute "C:\Users\sdkca\Desktop\TUTORIAL2.txt"
    # localFilePath = './toA/DSC08284.JPG'
    #
    # # Define the remote path where the file will be uploaded
    # remoteFilePath = '/var/integraweb-db-backups/DSC08284.JPG'
    #
    # sftp.put(localFilePath, remoteFilePath)

# connection closed automatically at the end of the with-block

# import pysftp
#
# with pysftp.Connection('pilot.cp.su.ac.th', username='u07580529', password='Ff012426484') as sftp:
#     with sftp.cd('public'):             # temporarily chdir to public
#         sftp.put('/my/local/filename')  # upload file to public/ on remote
#         sftp.get('remote_file')         # get a remote file
