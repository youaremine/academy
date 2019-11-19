/*!
 * only for main_schedule_list.html
 *
 * Date: Jan 29 2013
 */

$(function () {
    $('a[rel*=leanModal]').leanModal({
        top: 200,
        closeButton: ".modal_close"
    });
    // init select value
    $('a[rel*=leanModal][href=#signup]').click(function () {
        $('#company').val($('#company_code_' + this.id).val());
        $('#signup_id').val(this.id);
    });
    // update contractor
    $('#btnSignupSubmit').click(
        function () {
            var signup_id = $('#signup_id').val();
            var company = $('#company').val();
            $('#company_code_' + signup_id).val(company);
            var companyName = $('#company').find("option:selected").text();
            $('#company_name_' + signup_id).html(companyName);
            var jobNoNew = $('#jobNoNew_' + signup_id).html();
            var mscId = $('#mscId_' + signup_id).val();
            $.ajax({
                type: "GET",
                url: "api/main.php",
                data: "q=assignContractor&jobNoNew=" + jobNoNew
                + "&company=" + company + "&mscId=" + mscId,
                dataType: "json",
                success: function (msg) {
                    $('#mscId_' + signup_id).val(msg.mscId);
                    // hide singup form.
                    $('#signup').hide();
                    $('#lean_overlay').hide();
                    // show tips
                    showTips("已将调查(" + jobNoNew + ")委派给." + companyName,
                        35, 5);
                }
            });
        });

    // init date value
    $('a[rel*=leanModal][href=#plannedSurveyDateDialog]').click(
        function () {
            var rowNo = this.id.split('_')[1];
            var rowNos = "";
            if (rowNo == "All") {
                $("input[name='chkRowNo']").each(function () {
                    if ($(this).attr("checked") == "checked") {
                        rowNos += $(this).val() + ",";
                    }
                });
                if (rowNos == "") {
                    // show tips
                    showTips("請先選擇需要批量更改的記錄。", 35, 5);
                    // hide dialog
                    $('#plannedSurveyDateDialog').hide();
                    $('#lean_overlay').hide();
                    return false;
                } else {
                    $('#rowNo').val(rowNos);
                }
            } else {
                $('#plannedSurveyDate').val(
                    $('#plannedSurveyDate_' + rowNo).html());
                $('#rowNo').val(rowNo);
            }
        });

    // update planned survey date
    $('#btnPlannedSurveyDateSubmit').click(
        function () {
            var plannedSurveyDate = $('#plannedSurveyDate').val();
            var jobNoNews = "";
            var rowNo = $('#rowNo').val();
            var rowNoArray = rowNo.split(",");
            if (rowNoArray.length > 1) {
                for (var i = 0; i < rowNoArray.length - 1; i++) {
                    var drRowNo = rowNoArray[i];
                    jobNoNews += $('#jobNoNew_' + drRowNo).html() + ",";
                    //$('#plannedSurveyDate_' + drRowNo).html(plannedSurveyDate);
                }
            } else {
                jobNoNews = $('#jobNoNew_' + rowNo).html();
                //$('#plannedSurveyDate_' + rowNo).html(plannedSurveyDate);
            }
            $.ajax({
                type: "GET",
                url: "api/main.php",
                data: "q=changePlannedSurveyDate&jobNoNew=" + jobNoNews
                + "&plannedSurveyDate=" + plannedSurveyDate,
                dataType: "json",
                success: function (msg) {
                    // hide singup form.
                    $('#plannedSurveyDateDialog').hide();
                    $('#lean_overlay').hide();
                    if (msg.success) {
                        // show tips
                        showTips("已将调查(" + jobNoNews + ")的計畫調查日期改為:" + plannedSurveyDate, 35, 5);
                        if (rowNoArray.length > 1) {
                            for (var i = 0; i < rowNoArray.length - 1; i++) {
                                var drRowNo = rowNoArray[i];
                                jobNoNew = $('#jobNoNew_' + drRowNo).html()
                                jobNoNew = jobNoNew.replace("(", "\\(");
                                jobNoNew = jobNoNew.replace(")", "\\)");
                                if (plannedSurveyDate == "") {
                                    $("#Assign_" + jobNoNew).hide();
                                    $("#UnAssign_" + jobNoNew).hide();
                                } else {
                                    $('#plannedSurveyDate_' + drRowNo).html(plannedSurveyDate);
                                    if ($("#surveyorCode_" + jobNoNew).html() == "") {
                                        $("#Assign_" + jobNoNew).show();
                                        $("#UnAssign_" + jobNoNew).hide();
                                    } else {
                                        $("#Assign_" + jobNoNew).hide();
                                        $("#UnAssign_" + jobNoNew).show();
                                    }
                                }
                            }
                        } else {
                            jobNoNew = $('#jobNoNew_' + rowNo).html();
                            jobNoNew = jobNoNew.replace("(", "\\(");
                            jobNoNew = jobNoNew.replace(")", "\\)");
                            $('#plannedSurveyDate_' + rowNo).html(plannedSurveyDate);
                            if (plannedSurveyDate == "") {
                                $("#Assign_" + jobNoNew).hide();
                                $("#UnAssign_" + jobNoNew).hide();
                            } else {
                                if ($("#surveyorCode_" + jobNoNew).html() == "") {
                                    $("#Assign_" + jobNoNew).show();
                                    $("#UnAssign_" + jobNoNew).hide();
                                } else {
                                    $("#Assign_" + jobNoNew).hide();
                                    $("#UnAssign_" + jobNoNew).show();
                                }
                            }
                        }
                    }
                    else {
                        // show tips
                        showTips("失败，未将调查(" + jobNoNews + ")的計畫調查日期改為:" + plannedSurveyDate, 35, 5);
                    }
                }
            });
        });

    // check all/check none
    $("#chkAll").click(function () {
        var isChecked = false;
        if ($(this).attr("checked") == "checked")
            isChecked = true;
        $("input[name='chkRowNo']").attr("checked", isChecked);
    });

    // 初始化选中的行数
    $('a[rel*=leanModal][href=#openJobDialog]').click(function () {
        var rowNo = this.id.split('_')[1];
        var rowNos = "";
        if (rowNo == "All") {
            //隐藏关联的job
            $('#relationJobNoNew1').val('');
            $('#relationJobNoNew2').val('');
            $('#relationJobNoNew3').val('');
            $('#divRelationJobNoNew1').hide();
            $('#divRelationJobNoNew2').hide();
            $('#divRelationJobNoNew3').hide();
            var errorJobNoNew = '';
            var trueJobNoNew = '';
            $("input[name='chkRowNo']").each(function () {
                if ($(this).attr("checked") == "checked") {
                    var _rowNo = $(this).val();
                    var _jobNoNew = $('#jobNoNew_' + _rowNo).html();
                    if ($('#openJobChange_' + _rowNo).is(':hidden')) {
                        errorJobNoNew += _jobNoNew + ',';
                    }else{
                        //判断当前调查是否已有调查员
                        _jobNoNew = _jobNoNew.replace("(", "\\(");
                        _jobNoNew = _jobNoNew.replace(")", "\\)");
                        if( $('#surveyorCode_' + _jobNoNew).html() != '') {
                            $('#openJobChange_' + _rowNo).hide();
                            $('#openJobDisable_' + _rowNo).show();
                            errorJobNoNew += _jobNoNew + ',';
                        }else{
                            trueJobNoNew += _jobNoNew + ',';
                        }
                    }
                    rowNos += _rowNo + ",";
                }
            });
            if (rowNos == "") {
                // show tips
                showTips("請先選擇需要批量更改的記錄。", 35, 5);
                // hide dialog
                $('#openJobDialog').hide();
                $('#lean_overlay').hide();
                return false;
            } else if (errorJobNoNew != '') {
                showTips(errorJobNoNew + "不符合開放條件。", 35, 5);
                // hide dialog
                $('#openJobDialog').hide();
                $('#lean_overlay').hide();
                return false;
            } else {
                $('#rowNo').val(rowNos);
                $('#openJobJobNoNew').html(trueJobNoNew);
            }
        } else {
            //判断当前调查是否已有调查员
            var _jobNoNew = $('#jobNoNew_' + rowNo).html();
            _jobNoNew = _jobNoNew.replace("(", "\\(");
            _jobNoNew = _jobNoNew.replace(")", "\\)");
            if( $('#surveyorCode_' + _jobNoNew).html() != '') {
                $('#openJobChange_' + rowNo).hide();
                $('#openJobDisable_' + rowNo).show();
                $('#openJobDisable_' + rowNo).attr('title','此調查不符合開放條件');
                //隐藏弹出的框
                $('#openJobDialog').hide();
                $('#lean_overlay').hide();
                return false;
            }
            //显示关联的job
            $('#divRelationJobNoNew1').show();
            $('#divRelationJobNoNew2').show();
            $('#divRelationJobNoNew3').show();
            rowNos = rowNo;
            $('#rowNo').val(rowNos);
            $('#openJobJobNoNew').html($('#jobNoNew_' + rowNos).html());
        }
    });

    // 提交资料
    $('#btnOpenJobSubmit').click(
        function () {
            var jobNoNews = "";
            var rowNo = $('#rowNo').val();
            var rowNoArray = rowNo.split(",");
            if (rowNoArray.length > 1) {
                for (var i = 0; i < rowNoArray.length - 1; i++) {
                    var drRowNo = rowNoArray[i];
                    jobNoNews += $('#jobNoNew_' + drRowNo).html() + ",";
                }
            } else {
                jobNoNews = $('#jobNoNew_' + rowNo).html();
                $('#divRelationJobNoNew1').show();
                $('#divRelationJobNoNew2').show();
                $('#divRelationJobNoNew3').show();
            }
            var relationJobNoNews = "";
            relationJobNoNews += $('#relationJobNoNew1').val() + ",";
            relationJobNoNews += $('#relationJobNoNew2').val() + ",";
            relationJobNoNews += $('#relationJobNoNew3').val() + ",";
            $.ajax({
                type: "GET",
                url: "api/main.php",
                data: "q=openJob&jobNoNews=" + jobNoNews + "&relationJobNoNews=" + relationJobNoNews,
                dataType: "json",
                success: function (msg) {
                    // hide singup form.
                    $('#openJobDialog').hide();
                    $('#lean_overlay').hide();
                    if (msg.success) {
                        if (rowNoArray.length > 1) {
                            for (var i = 0; i < rowNoArray.length - 1; i++) {
                                var drRowNo = rowNoArray[i];
                                $('#openJobChange_' + drRowNo).hide();
                                $('#openJobDisable_' + drRowNo).show();
                            }
                        } else {
                            $('#openJobChange_' + rowNo).hide();
                            $('#openJobDisable_' + rowNo).show();
                        }
                        // show tips
                        showTips("已将调查(" + jobNoNews + ")開放出去.", 35, 5);
                    }
                    else {
                        // show tips
                        showTips("失败，未能将调查(" + jobNoNews + ")開放出去.", 35, 5);
                    }
                }
            });
        });

});