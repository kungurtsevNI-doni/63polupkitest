document.addEventListener("DOMContentLoaded", domLoaded);

function domLoaded()
{
    // var table = new FixTable(this);
    // table.StyleColumns();
    // table.FixColumns();
    $('.table-my>thead>tr>td').each(function(){
        $(this).hover(function () {
           // console.log(this);
            $(this).css('background-color','#9ec3b3');
        },function () {
            $(this).css('background-color','#FFFFFF');
            }
        );
    });
    $('.table-my>tbody>tr:nth-child(2n+1)>td,' +
        '.table-my-open-offices>tbody>tr:nth-child(2n+1)>td').each(function(){
        $(this).hover(function () {
               // console.log(this);
                $(this).css('background-color','rgb(232, 220, 220)');
            },function () {
                $(this).css('background-color','#FFFFFF');
            }
        );
    });
}
// //КОнструктор класса финксированной шапки
// function FixTable(table)
// {
//     var inst = this;
//     this.table = table;
//     $('tr > th', $(this.table)).each(function(index,element){
//         var div_fixed = $('<div/>').addClass('fixtable-fixed');
//         var div_relat = $('<div/>').addClass('fixtable-relative');
//         div_fixed.html($(this).html);
//         div_relat.html($(this).html);
//         $(this).html('').append(div_fixed).append(div_relat);
//         $(div_fixed).hide();
//     });
//     //Сделать текст по центру
//     $(window).scroll(function(){
//         inst.FixColumns();
//     }).resize(function(){
//         inst.StyleColumns();
//     });
// }
//
// FixTable.prototype.StyleColumns = function() {
//     $('tr>th').each(function(){
//         $('div.fixtabe-fixed',$(this)).css({
//             'width': $(this).outerWidth() - 16 -1 + 'px',
//             'height': $(this).outerHeight() - 2 + 'px',
//             'left' : $(this).offset().left + 'px',
//             'padding-left': $(this).css('padding-left'),
//             'padding-right': $(this).css('padding-right')
//         });
//     });
// }
//
// FixTable.prototype.FixColumns = function()
// {
//     var inst = this;
//     var show = false;
//     var s_top = $(window).scrollTop();
//     var h_top = $(inst.table).offset().top;
//
//     if(s_top< ($(inst.table).height() - $(inst.table).find('.fixtable-fixed')) && s_top > h_top){
//         show = true;
//         console.log('enter');
//     }
//     $('tr > th > div.fixtabe-fixed', $(this.table)).each(function(){
//         show ? $(this).show() : $(this).hide()
//     });
// }
