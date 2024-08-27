<script>
    $(document).ready(function () {

        var width = 720, height = 320;
        var $modalBackgroundImage = $('#modal');
        var photoInput = '#background_photo';
        var imageId = '#backgroundImage';
        var isAvatar = false;

        var image = document.getElementById('sample_image');

        var cropper;

        $('#upload-cover-image').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image.src = url;
                width = 720;
                height = 300;
                photoInput = '#background_photo';
                imageId = '#backgroundImage';
                isAvatar = false;
                $modalBackgroundImage.modal('show');
                document.getElementById('crop').innerHTML = 'Обрезать';
                document.getElementById('crop').disabled = false;
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $('#profile-image').change(function (event) {
            var files = event.target.files;

            var done = function (url) {
                image.src = url;
                width = 256;
                height = 256;
                photoInput = '#photo';
                imageId = '#profileImage';
                isAvatar = true;
                $modalBackgroundImage.modal('show');
                document.getElementById('crop').innerHTML = 'Обрезать';
                document.getElementById('crop').disabled = false;
            };

            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modalBackgroundImage.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: width/height,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: width,
                height: height
            });

            document.getElementById('crop').innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Загрузка...';
            document.getElementById('crop').disabled = true;

            canvas.toBlob(function (blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                var route = '{{ route('profile.uploadBackgroundImage') }}';
                if (isAvatar) {
                    route = '{{ route('profile.uploadPhoto') }}';
                }
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    var token = $("input[name='_token']").val();
                    $.ajax({
                        url: route,
                        method: 'POST',
                        data: {
                            _token: token,
                            image: base64data
                        },
                        success: function (data) {
                            $modalBackgroundImage.modal('toggle');
                            $(photoInput).val(data);
                            if (isAvatar) {
                                $(imageId).attr('src', '{{ asset(\App\Services\Common\Helpers\Image\ImageFolderHelper::USERS_PHOTO_PATH) }}/' + data).show();
                            }
                            else {
                                $(imageId).css('background-image', 'url("{{ asset(\App\Services\Common\Helpers\Image\ImageFolderHelper::USERS_PHOTO_PATH) }}/' + data + '")').show();
                            }
                        }
                    });
                    document.getElementById('upload-cover-image').value = "";
                    document.getElementById('profile-image').value = "";
                };
            });
        });


        IMask(document.getElementById('phone'), { mask: '+{992}(00)000-00-00' });

        document.getElementsByClassName('flatpickr-input').forEach(function (item) {
            item.flatpickr(jQuery.parseJSON(item.dataset.options));
        })
    });

    $('#modal').on('hidden.bs.modal', function () {
        document.getElementById('upload-cover-image').value = "";
        document.getElementById('profile-image').value = "";
    });

</script>
