{{-- AngularJS --}}
{{ HTML::script('http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js') }}
{{ HTML::script('https://code.angularjs.org/1.2.26/i18n/angular-locale_es-cl.js') }}
{{-- Main app --}}
{{ HTML::script('js/app.js') }}
{{-- Factory root --}}
<script>
    trackingCorreos.factory('rootFactory', function () {
        var servicio = {
            root: "{{ Request::root() }}"
        };
        return servicio;
    });
</script>
{{-- Components --}}
{{ HTML::script('js/factories.js') }}
{{ HTML::script('js/directives.js') }}
{{ HTML::script('js/controllers.js') }}
