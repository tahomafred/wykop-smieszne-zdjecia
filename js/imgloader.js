$(function () {
    this.page = 1;
    this.tag = $('#tag-form-name');
    this.tagVal = this.tag.val();
    this.form = $('#tag-form');
    this.container = $('#img-container');

    this.loadPage = function ($page) {
        var $this = this;

        if (this.tag.val().length < 3)
            return;

        $.ajax({
            url: '?json=1&tag=' + this.tag.val() + '&page=' + this.page,
            type: 'GET',
            success: function (data) {
                if (!data) return;

                $.each(data, function (key, val) {
                    $this.container.append('<a href="' + val.url + '"><img class="block img.responsive img-rounded" src="' + val.thumbnail + '"></a>');
                });

                $('<div class="block img.responsive img-rounded img-loader bg-primary">ładuj wincyj!!!</div>').appendTo($this.container)
                    .click(function () {
                        this.remove();
                        $this.triggerPageLoad();
                    });
            },
            error: function () {

            }
        });
    };

    this.init = function () {
        var $this = this;

        this.form.submit(function (event) {
            event.preventDefault();

            $this.page = 1;
            $this.tagVal = $this.tag.val();
            $this.container.html('');

            $this.triggerPageLoad();
        });
    };

    this.triggerPageLoad = function () {
        this.loadPage(this.page);
        this.page++;
    };

    this.init();

});