exports.log = function (err, data) {
    console.log(data.toString().split('\n').length-1)
    if(err) {
        console.log('we got an error!: ',err)
    }
}