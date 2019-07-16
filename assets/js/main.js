var pidie = new Pidie();

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()


    // const pathname = window.location.pathname.substr(1);
    // if (pathname === 'login.php') {
    //
    //     $(".login").hide();
    //     $(".register").show();
    // }

    // $('.my-select').selectpicker();

    addTranslateLisner();




    $(".nav-tabs").on("click", "a", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('add-language')) {
            $(this).tab('show');
        }
        const href = $(this).attr("href").replace('#', '');
        if (href) {
            showLang(href.split('_')[1])
        }
        console.log("href", href)
    })
        .on("click", "span", function () {
            var anchor = $(this).siblings('a');
            $(anchor.attr('href')).remove();
            $(this).parent().remove();
            $(".nav-tabs li").children('a').first().click();
        });

    function addLang() {

        $('.add-language').prop('onclick',null).off('click');

        $('.add-language').click(function (e) {
            e.preventDefault();
            var id = $(".nav-tabs").children().length; //think about it ;)
            var tabId = 'contact_' + id;
            // $(this).closest('li').before('<li><a href="#contact_' + id + '">New Tab</a> <span> x </span></li>');

            $(this).closest('li').before(`
            <li class="nav-item"> 
                <a class="nav-link" id="lang-${id}-tab" href="#lang_${id}" data-toggle="tab">New<span>x</span></a>
            </li>
        `);

            //add select
            $('.tabs-content .select-box').append(`
            <div class="pd-flag-select pd-flag-primary pd-search-select translate lang-${id}" tab-leng="${id}">
                <select class="pd-languages lang-${id}" name="lang-${id}" onchange="onChangeLanguage(this)"></select>
            </div>
        `)

            pidie.flagSelectBox(`${id}`);

            // tarnslares
            $('.translate-container').each(function (i) {
                const termTranslate = i + 1;
                const required = termTranslate <= 3 ? "required" : "";
                $(this).append(`
                <div class="col-md-5 translate translate-container" tab-leng="${id}" tab-term-translate="${termTranslate}">
                    <input class="col-md-12" type="text" name="lang-${id}_term-${termTranslate}_translate-1" ${required}>
                    <a href="#" class="add-translate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            `);
            })

            showLang(id);

            $('.nav-tabs li:nth-child(' + id + ') a').click();
            addTranslateLisner();
            addLang();

        });
    }

    addLang();



    function showLang(num) {
        $(".tabs-content .translate").each(function (index)  {
             if ($(this).attr('tab-leng') === num) {
                 $(this).show();
             } else {
                 $(this).hide();
             }
        })
        // console.log($(".tabs-content .lang"))
    }


})



function onChangeLanguage(e) {
    const flagCountry = pidie.countries();
    const value = e.options[e.selectedIndex].value;
    const name = e.getAttribute('name');
    let currentLang;

    for (let i = 0; i < flagCountry.length; i++ ) {
        const arr = value.split('-');
        if (flagCountry[i].id === arr[1] && flagCountry[i].language_code === arr[0]) {
            currentLang = flagCountry[i];
            break;
        }
    }
    console.log("name", name)

    const tabs = document.getElementById(name + '-tab');

    const flagArr = document.createElement("div");

    const flag = `<div data-toggle="tooltip" data-placement="top" title="Tooltip on top" style="height: 32px; width: 32px;"><i class="flag flag-${currentLang.id.toLowerCase()}"></i></div>`;

    tabs.innerHTML = flag;
    $('[data-toggle="tooltip"]').tooltip()
}

function addTranslateLisner() {
    $('.add-translate').prop('onclick',null).off('click');
    $('.add-translate').each(function( index ) {
        $(this).click((e) => {
            e.preventDefault();
            
            const name = $(this).siblings().first().attr("name").split("_");
            const tramnsId = $(this).siblings('.col-md-12').length + 1;
            const html = `<input class="col-md-12 mt-3" type="text" name="${name[0]}_${name[1]}_translate-${tramnsId}">`;
            $(this).before(html);
        })
    });
}


