/**
 * Created by James on 2015-12-11.
 */
$(function() {
    $('#btnSearchSalary').on('click',function(){
       document.location = './salary.php';
    });
    $('#btnSearchJobs').on('click',function(){
        //document.location = './jobs_3.php';
        document.location='../templates/account/jobs_4.html';
    });
    $('#btnMyCalendar').on('click',function(){
        document.location = '../surveyor_calendar.php';
    });
});