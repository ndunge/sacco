
var express = require('express');
var router = express.Router();
var sql = require ('mssql');


router.get('/', function(req, res, next) {
    res.render('loancal');
});


const config = {
    user: 'SaccoUser',
    password: 'Sacco@123',
    server: 'DESKTOP-O4S5OLB\\NAVDEMO', // You can use 'localhost\\instance' to connect to named instance
    database: 'Demo Database NAV (11-0)',

    options: {
        encrypt: false // Use this if you're on Windows Azure
    }
};
sql.connect(config).then(() => {
        return sql.query`select [Credit Name] from [Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$Credits Type]`
    }).then(result => {
        console.log(result)
        // Pass the DB result to the template
        res.render('loancalc', {dropdownVals: result})
    }).catch(err => {
        console.log(err)
    })
