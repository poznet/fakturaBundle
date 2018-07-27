# fakturaBundle

###
To render FV form use `{% include '@poznetFaktura/fakturaForm.html.twig' %}`

### Parameters

`faktura_termin_days` - domyślny termin płatności na fv 

Also you need to define invoice header data in parameters

    faktura_dane:
       nazwa: Company name
       adres1: 43-400 city
       adres2: street 12
       nip: 123-123-12-13
       
and make it globals in config.yml

    twig:
        globals:
            faktura_dane: "%faktura_dane%"