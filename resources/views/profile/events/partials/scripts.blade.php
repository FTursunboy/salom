<script>
    ClassicEditor
        .create(document.querySelector('#event-text'))
        .catch(error => {
            console.error(error);
        });

    $(document).ready(function () {

        let avatarImg = $('#avatarImg');

        if (avatarImg.attr('src').length === 0) {
            avatarImg.hide();
        }

        var $modal = $('#modal');

        var image = document.getElementById('sample_image');

        var cropper;

        $('#upload-cover-image').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image.src = url;
                $modal.modal('show');
                document.getElementById('crop').innerHTML = 'Обрезать';
                document.getElementById('crop').disabled = false;
            };

            console.log(files);

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 720/300,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 720,
                height: 300
            });

            document.getElementById('crop').innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Загрузка...';
            document.getElementById('crop').disabled = true;

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: '{{ route('profile.events.uploadImage') }}',
                        method: 'POST',
                        data: {
                            _token: token,
                            image: base64data
                        },
                        success: function (data) {
                            $modal.modal('toggle');
                            $('#photo').val(data);
                            $('#avatarImg').attr('src', '{{ asset(\App\Services\Common\Helpers\Image\ImageFolderHelper::TEMP_IMAGES_PATH) }}/' + data).show();
                        }
                    });
                    document.getElementById('upload-cover-image').value = "";
                };
            });
        });


        let phones = document.getElementsByClassName('phones');
        phones.forEach(function (item) {
            IMask(item, { mask: '+{992}(00)000-00-00' });
        })
    });

    $('#modal').on('hidden.bs.modal', function () {
        document.getElementById('upload-cover-image').value = "";
    });

    function validateFormBeforeSubmit(e) {
        let photo = document.getElementById('photo').value;
        if (photo.trim().length === 0) {
            alert('Фото обложки обязательно');
            return false;
        }
        let address = document.getElementById('address').value;
        if (address.trim().length === 0) {
            alert('Адрес обязательно. Сначала указывайте адрес');
            return false;
        }

        let phones = document.getElementsByClassName('phones');

        phones.forEach(function (item) {
            let phone = item;
            phone = phone.replace('+', '').replace('(', '').replace(')', '').replaceAll('-', '');
            item.val(phone);
        });

        return true;
    }

    $('.event-schedule-btn').on('click', removeEventSchedule)

    function removeEventSchedule() {
        let number = this.dataset.number;
        document.getElementById('event_schedule_' + number).remove();
    }

    $('#add_event_schedule').on('click', function () {
        const container = document.getElementById("event_schedules");
        const template = document.getElementById("event_schedule_template");
        const firstClone = template.content.cloneNode(true);

        let elements = document.getElementsByClassName('event-schedule-btn');
        let maxNumber = 1;
        elements.forEach(function (element) {
            maxNumber = element.dataset.number;
        })
        maxNumber++;

        firstClone.getElementById('event_schedule_template').id = 'event_schedule_' + maxNumber;
        firstClone.getElementById('event_schedule_number').id = 'event_schedule_number' + maxNumber;

        firstClone.getElementById('event_schedule_title_template').name = 'event_schedules[' + maxNumber + '][title]';
        firstClone.getElementById('event_schedule_start_date_template').name = 'event_schedules[' + maxNumber + '][start_date]';
        firstClone.getElementById('event_schedule_start_time_template').name = 'event_schedules[' + maxNumber + '][start_time]';
        firstClone.getElementById('event_schedule_end_date_template').name = 'event_schedules[' + maxNumber + '][end_date]';
        firstClone.getElementById('event_schedule_end_time_template').name = 'event_schedules[' + maxNumber + '][end_time]';

        firstClone.getElementById('event_schedule_number' + maxNumber).dataset.number = maxNumber;
        firstClone.getElementById('event_schedule_number' + maxNumber).addEventListener("click", removeEventSchedule);

        container.appendChild(firstClone);

        document.getElementsByClassName('flatpickr-input').forEach(function (item) {
            item.flatpickr(jQuery.parseJSON(item.dataset.options));
        })
    });

    ymaps.ready(init);

    function init() {
        var myPlacemark,
            myMap = new ymaps.Map('map', {
                center: [38.576271, 68.779716],
                zoom: 12
            }, {
                searchControlProvider: 'yandex#search'
            });

        // Слушаем клик на карте.
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            setCoordinate(coords);
        });

        let latitude = document.getElementById('latitude').value;
        let longitude = document.getElementById('longitude').value;

        if (latitude && longitude) {
            setCoordinate([latitude, longitude])
        }

        function setCoordinate(coords) {
            document.getElementById('latitude').value = coords[0];
            document.getElementById('longitude').value = coords[1];

            // Если метка уже создана – просто передвигаем ее.
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else {
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
            }
            getAddress(coords);
        }

        $("#popular_place").on('change', function () {
            if (this.options.length) {
                setCoordinate(this.options[0].dataset.customProperties.split('#'))
            }
        });

        // Создание метки.
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconCaption: 'поиск...'
            }, {
                preset: 'islands#violetDotIconWithCaption',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование).
        function getAddress(coords) {
            myPlacemark.properties.set('iconCaption', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                /**
                 * Все данные в виде javascript-объекта.
                 */
                console.log('Все данные геообъекта: ', firstGeoObject.properties.getAll());
                /**
                 * Метаданные запроса и ответа геокодера.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderResponseMetaData.xml
                 */
                console.log('Метаданные ответа геокодера: ', res.metaData);
                /**
                 * Метаданные геокодера, возвращаемые для найденного объекта.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderMetaData.xml
                 */
                console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
                /**
                 * Точность ответа (precision) возвращается только для домов.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/precision.xml
                 */
                console.log('precision', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision'));
                /**
                 * Тип найденного объекта (kind).
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/kind.xml
                 */
                console.log('Тип геообъекта: %s', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind'));
                console.log('Название объекта: %s', firstGeoObject.properties.get('name'));
                console.log('Описание объекта: %s', firstGeoObject.properties.get('description'));
                console.log('Полное описание объекта: %s', firstGeoObject.properties.get('text'));
                /**
                 * Прямые методы для работы с результатами геокодирования.
                 * @see https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeocodeResult-docpage/#getAddressLine
                 */
                console.log('\nГосударство: %s', firstGeoObject.getCountry());
                console.log('Населенный пункт: %s', firstGeoObject.getLocalities().join(', '));
                console.log('Адрес объекта: %s', firstGeoObject.getAddressLine());
                console.log('Наименование здания: %s', firstGeoObject.getPremise() || '-');
                console.log('Номер здания: %s', firstGeoObject.getPremiseNumber() || '-');

                myPlacemark.properties
                    .set({
                        // Формируем строку с данными об объекте.
                        iconCaption: [
                            // Название населенного пункта или вышестоящее административно-территориальное образование.
                            firstGeoObject.getLocalities().length ? firstGeoObject.getLocalities() : firstGeoObject.getAdministrativeAreas(),
                            // Получаем путь до топонима, если метод вернул null, запрашиваем наименование здания.
                            firstGeoObject.getThoroughfare() || firstGeoObject.getPremise()
                        ].filter(Boolean).join(', '),
                        // В качестве контента балуна задаем строку с адресом объекта.
                        balloonContent: firstGeoObject.getAddressLine()
                    });
                document.getElementById('address_detail').innerHTML = firstGeoObject.getAddressLine();
                document.getElementById('address').value = firstGeoObject.properties.get('name');
                document.getElementById('country').value = firstGeoObject.getCountry();

                document.getElementById('city').value = "";
                if (firstGeoObject.getLocalities().length > 0) {
                    document.getElementById('city').value = firstGeoObject.getLocalities()[0];
                }
            });
        }
    }

    $('input[type=radio][name=event_type]').change(function () {
        if (this.value === 'paid') {
            $('#ticket_amount').removeClass('d-none');
        } else {
            $('#ticket_amount').addClass('d-none');
        }
    });

    $('#add_phone').on('click', function () {
        const container = document.getElementById("phones");
        const template = document.getElementById("add_phone_template");
        const cloneEl = template.content.cloneNode(true);

        let elements = document.getElementsByClassName('phones');
        let maxNumber = 1;
        elements.forEach(function (element) {

            maxNumber = element.dataset.number;
        })
        maxNumber++;

        cloneEl.getElementById('phones_template').id = 'phones_' + maxNumber;
        cloneEl.getElementById('phones_group_template').id = 'phones_group_' + maxNumber;
        cloneEl.getElementById('phones_' + maxNumber).dataset.number = maxNumber;
        cloneEl.getElementById('btn_phones_template').id = 'btn_phones_' + maxNumber;
        cloneEl.getElementById('btn_phones_' + maxNumber).dataset.number = maxNumber;

        console.log(maxNumber);
        container.appendChild(cloneEl);

        IMask(document.getElementById('phones_' + maxNumber), { mask: '+{992}(00)000-00-00' });
    });

    function removePhone(el) {
        document.getElementById('phones_group_' + el.dataset.number).remove();
    }

    $('#add_site').on('click', function () {
        const container = document.getElementById("sites");
        const template = document.getElementById("add_site_template");
        const cloneEl = template.content.cloneNode(true);

        let elements = document.getElementsByClassName('sites');
        let maxNumber = 1;
        elements.forEach(function (element) {
            maxNumber = element.dataset.number;
        })
        maxNumber++;

        cloneEl.getElementById('sites_template').id = 'sites_' + maxNumber;
        cloneEl.getElementById('sites_group_template').id = 'sites_group_' + maxNumber;
        cloneEl.getElementById('btn_sites_template').id = 'btn_sites_' + maxNumber;
        cloneEl.getElementById('btn_sites_' + maxNumber).dataset.number = maxNumber;

        console.log(maxNumber);
        container.appendChild(cloneEl);
    });

    function removeSite(el) {
        document.getElementById('sites_group_' + el.dataset.number).remove();
    }
</script>
