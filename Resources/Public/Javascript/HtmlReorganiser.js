var xmlHttp;

// Both arrays below are used for translations
var partsOfForm = [
    'germany',
    'uk',
    'france',
    'spain',
    'austria',
    'switzerland',
    'liechtenstein',
    'luxembourg',
    'belgium',
    'australia',
    'canada',
    'ireland',
    'other',
    'units',
    'country',
    'new_zealand',
    'city_label',
    'language'
];
var group = [
    'german',
    'english',
    'french',
    'spanish',
    'metric',
    'imperial'
];
var NotAvailableTranslations = {'en': 'N/A', 'fr': 'nd', 'es': 'ND', 'de': 'n.d.'};
var RequestTranslations = {
    'en': 'Please fill the form out',
    'fr': 'Remplissez le formulaire',
    'es': 'Rellene el formulario a cabo',
    'de': 'Bitte füllen Sie das Formular aus'
};

// Array below is for translation and filling in some weather data
var aspects = [
    'humidity',
    'visibility',
    'pressure',
    'precipitation',
    'sunrise',
    'sunset'
];

function alterButton() {
    /*
     Alters submitting button to simple button. Browsers with JavaScript can take advantage of JavaScript,
     and other browsers can still submit via PHP only.
     */
    document.getElementById('button').setAttribute('type', 'button');
}

function getNewReport() {
    try {
        var city = document.getElementById('city').value;
        var country = document.getElementById('nation').value;
        var language = document.querySelector('input[name="language"]:checked').value;
        var units = document.querySelector('input[name="units"]:checked').value;

        // Try to construct a HTTP request
        if (window.XMLHttpRequest) {
            xmlHttp = new XMLHttpRequest();
        } else {
            try {
                xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
            }
            catch (invalid) {
                xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
            }
        }

        // Send request and show results
        if (xmlHttp !== null) {
            xmlHttp.open('POST', 'Functions/Main/NewReportDisplayer.php', true);
            xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlHttp.onreadystatechange = showRequestedReport;
            xmlHttp.send('city=' + city + '&country=' + country + '&language=' + language + '&units=' + units);
        }
    }
    catch (error) {
        // Alert user if he/she does not select a language and units in an understandable manner
        if (error = 'document.querySelector(...) is null') {
            requestFilledOutForm(language);
        }
    }
}

function showRequestedReport() {
    // If status from OpenWeatherMap is okay
    if (xmlHttp.readyState === 4 && xmlHttp.status >= 200 && xmlHttp.status < 400) {
        // Get response from Ajax in appropriate format
        var report = JSON.parse(xmlHttp.responseText);

        // Prepare titles
        var title = document.getElementById('title');
        title.innerHTML = report.TITLE + ': ' + report.CITY_VALUE + ' ' + report.COUNTRY_VALUE + ' ';
        document.getElementById('now').innerHTML = report.DT_VALUE;

        // Translate "photo by" in footer
        document.getElementById('photographer').innerHTML = report.PHOTO_BY + ' ' + report.PHOTOGRAPHER;

        // Translate form
        translatePartsOfForm(report);
        // Button and radio buttons translated separately
        var button = document.getElementById('button');
        setAttributes(button, {'name': report.ENTER, 'value': report.ENTER});
        translateRadioButtons(report);

        var hideable = document.getElementsByClassName('hideable');
        if (report.SUNSET_LABEL == null) {
            // If no weather data is obtained, the HTML section giving weather details is left out
            changeVisibility(hideable, 'hidden');
        } else {
            // Ensure all sections that might have been hidden previously are shown
            changeVisibility(hideable, 'visible');

            /*
             If weather data is obtained, insert all other available information.
             Show latitude and longitude.
             */
            document.getElementById('place').innerHTML = report.LON_LABEL + ' ' + report.LON_VALUE +
                '&#160;&#160;&#160;' + report.LAT_LABEL + ' ' + report.LAT_VALUE;

            var temperatureSection = document.getElementById('temp');
            temperatureSection.innerHTML = report.TEMP_VALUE;

            // Depict weather description
            showWeatherDescription(report, temperatureSection);

            // Configure arrow showing wind direction and intensity
            showWindInformation(report);

            // Fill listed items
            showListedInformation(report);
        }
    }
}

function setAttributes(element, attributes) {
    // Set and/or alter a group of attributes for one element
    for (var key in
        attributes) {
        element.setAttribute(key, attributes[key]);
    }
}

function translateNotAvailable(element, report, bool) {
    for (var key in
        NotAvailableTranslations) {
        if (report.language == key) {
            // If bool is true, text (rather than an attribute), must be altered
            if (bool == true) {
                element.innerHTML = NotAvailableTranslations[key];
            }
            else {
                element.setAttribute('title', report.WIND_SPEED_VALUE + ' ' + NotAvailableTranslations[key]);
            }
        }
    }
}

function changeVisibility(hideable, visibility) {
    for (index = 0;
         index < hideable.length;
         index++) {
        hideable[index].style.visibility = visibility;
    }
}

function requestFilledOutForm(language) {
    if (!language) {
        // Default language, if user has not selected one in the form, is German
        alert('Bitte füllen Sie das Formular aus');
    } else {
        for (var key in
            RequestTranslations) {
            if (language == key) {
                alert(RequestTranslations[key]);
            }
        }
    }
}

function showWindInformation(report) {
    // Arrow must be recreated and later appended, as it is wiped out by the innerHTML function
    var arrow = document.getElementById('arrow');
    if (report.WIND_DIRECTION_VALUE != null) {
        arrow.setAttribute('title', report.WIND_SPEED_VALUE + ' ' + report.WIND_DIRECTION_VALUE);
    } else {
        translateNotAvailable(arrow, report, false);
    }
    if (report.ROTATION != null) {
        arrow.style.webkitTransform = arrow.style.mozTransform = arrow.style.msTransform =
            arrow.style.oTransform = arrow.style.transform = 'rotate(' + report.ROTATION + ')';
    } else {
        // "rotate(270deg)" points arrow upwards if no information on wind direction available
        arrow.style.webkitTransform = arrow.style.mozTransform = arrow.style.msTransform =
            arrow.style.oTransform = arrow.style.transform = 'rotate(270deg)';
    }
    document.getElementById('head').setAttribute('class', report.ARROW_HEAD);
    document.getElementById('shaft').setAttribute('class', report.ARROW_SHAFT);

    document.getElementById('wind_label').innerHTML = report.WIND_LABEL;
}

function showListedInformation(report) {
    for (item = 0;
         item < aspects.length;
         item++) {
        var line = document.getElementById(aspects[item]);
        line.innerHTML = report[aspects[item].toUpperCase() + '_LABEL'];

        // Span elements must be recreated and appended, as the .innerHTML function removes them
        var span = document.createElement('span');
        var information = aspects[item].toUpperCase() + '_VALUE';
        if (report[information] != null) {
            span.innerHTML = report[information];
        } else {
            translateNotAvailable(span, report, true);
        }
        line.appendChild(span);
    }
}

function showWeatherDescription(report, temperatureSection) {
    var weatherDescriptionSection = document.getElementById('summary');
    weatherDescriptionSection.innerHTML = report.DESCRIPTION_VALUE;

    // innerHTML function removes image, so recreate and append it to temperature section
    var smallPicture = document.createElement('img');
    setAttributes(smallPicture, {
        'src': report.ICON,
        'alt': report.DESCRIPTION_VALUE,
        'title': report.DESCRIPTION_VALUE
    });
    temperatureSection.appendChild(smallPicture);

    // Change background image if necessary (depends on weather description)
    document.getElementsByTagName('body')[0].setAttribute('id', report.BODY);
}

function translateRadioButtons(report) {
    var labels = document.getElementsByTagName('label');
    for (index = 0;
         index < labels.length;
         index++) {
        for (item = 0;
             item < group.length;
             item++)
            if (labels[index].htmlFor == group[item]) {
                labels[index].innerHTML = report[group[item].toUpperCase()];
            }
    }
}

function translatePartsOfForm(report) {
    for (index = 0;
         index < partsOfForm.length;
         index++) {
        document.getElementById(partsOfForm[index]).innerHTML = report[partsOfForm[index].toUpperCase()];
    }
}