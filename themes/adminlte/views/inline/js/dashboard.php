(function($){ 
    "use strict"; 
  $(document).ready(function () {
      var currentLangCode = '<?= $this->repairer->get_cal_lang(); ?>';

      var date = new Date()
      var d    = date.getDate(),
          m    = date.getMonth(),
          y    = date.getFullYear()

      var Calendar = FullCalendar.Calendar;
      var calendarEl = document.getElementById('calendar');

      var calendar = new Calendar(calendarEl, {
        headerToolbar: {
          left  : 'prev,next today',
          center: 'title',
          right : 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        locale: currentLangCode,  

        //Random default events
        events:site.base_url + "panel/events/getAllEvents",
        editable  : true,
        selectable:true,
        selectHelper:true,

        select: function(data)
          {

            var start    = moment(data.start).format('Y-MM-DD HH:mm:ss');
            var end    = moment(data.end).format('Y-MM-DD HH:mm:ss');

            bootbox.prompt(lang.enter_event_title, function(title){ 
              if (title) {
                $.ajax({
                  url:site.base_url + "panel/events/add",
                  type:"POST",
                  data:{title:title, start:start, end:end},
                  success:function()
                  {
                    calendar.refetchEvents();
                    toastr.success(lang.event_added);
                  }
                })
              }
            });
          },

        eventDrop      : function(data) {
              var event = data.event;
              var start    = moment(event.start).format('Y-MM-DD HH:mm:ss');
              var end    = moment(event.end).format('Y-MM-DD HH:mm:ss');
              var title = event.title;
              var id = event.id;

              console.log(event);


            $.ajax({
              url:site.base_url + "panel/events/update",
              type:"POST",
              data:{title:title, start:start, end:end, id:id},
              success:function() {
                  calendar.refetchEvents();
                  toastr.success(lang.event_updated);
              }
            });
        },

          eventResize:function(data)
          {
          var event = data.event;
              var start    = moment(event.start).format('Y-MM-DD HH:mm:ss');
              var end    = moment(event.end).format('Y-MM-DD HH:mm:ss');
          var title = event.title;
          var id = event.id;
          $.ajax({
            url:site.base_url + "panel/events/update",
            type:"POST",
            data:{title:title, start:start, end:end, id:id},
            success:function(){
              calendar.refetchEvents();
            toastr.success(lang.event_updated);
            }
          })
          },


            eventClick:function(event)
            {
              bootbox.confirm({
                  message: lang.event_remove_r_u_sure,
                  buttons: {
                      confirm: {
                          label: lang.yes,
                          className: 'btn-success'
                      },
                      cancel: {
                          label: lang.no,
                          className: 'btn-danger'
                      }
                  },
                  callback: function (result) {
                      if (result) {
                        var id = event.event.id;
                        $.ajax({
                        url:site.base_url + "panel/events/delete",
                        type:"POST",
                        data:{id:id},
                        success:function()
                        {
                        calendar.refetchEvents();
                          toastr.success(lang.event_removed);
                        }
                        })
                      }
                  }
              });
            },


      });

      calendar.render();

    
      $('#send_email_form').parsley({
          errorsContainer: function(pEle) {
              var $err = pEle.$element.closest('.form-group');
              return $err;
          }
      }).on('form:submit', function(event) {
          $('#loadingmessage').show(); // show the loading message.
          let emailto = jQuery('#emailto_').val();
         let subject = jQuery('#subject_').val();
          let body = jQuery('#body_').val();
          jQuery.ajax({
              type: "POST",
              url: base_url + "panel/welcome/send_mail",
              data: "to=" + emailto + "&subject=" + subject + "&body=" + body,
              cache: false,
              dataType: "json",
              success: function(data) {
                  $('#loadingmessage').hide();
                  if (data == 2) {
                      toastr.error(lang.field_empty);
                  } else if (data == 1) {
                      toastr.info(lang.email_sent);
                  } else {
                      toastr.error(lang.email_not_sent);
                  }
              }
          });
          return false;
      });
      $('#send_quicksms').parsley({
          errorsContainer: function(pEle) {
              var $err = pEle.$element.closest('.form-group');
              return $err;
          }
      }).on('form:submit', function(event) {
          let dta = $('#send_quicksms').serialize();
          jQuery.ajax({
              type: "POST",
              url: base_url + "panel/reparation/send_sms",
              data: dta,
              cache: false,
              dataType: "json",
              success: function(data) {
                  if (data.status == true) toastr['success']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('
                      sms_sent ');?>');
                  else toastr['error']("<?= $this->lang->line('quick_sms');?>", '<?= $this->lang->line('
                      sms_not_sent ');?>');
              }
          });
          return false;
      });

      
      function gd(year, month, day) {
          return new Date(year, month - 1, day).getTime();
      }
          var areaData =  [ <?php if (count($list) <= 1): ?> 
                    ['01', 0]
                  <?php else: ?>
                  <?php for ($i = 1; $i <= 30; ++$i): ?> 
                    [(<?=strtotime($list[33].'-'.$list[32].'-'.$i);?> ), "<?= $list[$i]; ?>"],
                    <?php endfor; ?>
      
              <?php endif; ?>]
          $.plot('#area-chart', [areaData], {
            grid  : {
              borderWidth: 0
            },
            series: {
              shadowSize: 0, // Drawing is faster without shadows
              color     : '#00c0ef',
              lines : {
                fill: true //Converts the line chart to area chart
              },
            },
            yaxis : {
              show: true
            },
              xaxis: {
            mode: "time"
        }
          })
      
        });
      
          var donutChartCanvas = $('#stock-chart').get(0).getContext('2d')
          var donutData        = {
            labels: [
              lang.stock_value_by_price,
              lang.stock_value_by_cost,
              lang.profit_estimate,
            ],
            datasets: [
              {
                data: [<?php echo($stock->stock_by_price) ? $stock->stock_by_price : 0; ?>,<?php echo($stock->stock_by_cost) ? $stock->stock_by_cost : 0; ?>,<?php echo($stock->stock_by_price - $stock->stock_by_cost); ?>],
                backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
              }
            ]
          }
          var donutOptions     = {
            maintainAspectRatio : false,
            responsive : true,
          }
          new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
          })
          
})(jQuery); 
