nohup ./capturepackages.sh > log/capture.log &
nohup php push.php > log/push.log &
nohup ./updateflag.sh > log/updateflag.log &
nohup ./updatescore.sh > log/updatescore.log &
nohup ./updateround.sh > log/updateround.log &
