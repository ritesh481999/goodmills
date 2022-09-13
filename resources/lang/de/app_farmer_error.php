<?php

return [

    'country_id' => [
        'required' => "Das Feld country id ist erforderlich.",
    ], 
    'is_news_sms' => [
        'required' => "Das Feld für die Nachrichten-SMS ist erforderlich.",
        'in'=>"Die ausgewählte Nachrichtensendung ist ungültig.",
    ], 
    'is_marketing_sms' => [
        'required' => "Das Feld Marketing-SMS ist erforderlich.",
        'in'=>"Die ausgewählte Marketing-SMS ist ungültig.",
    ], 
    'is_bids_received_sms' => [
        'required' => "Das Feld Gebote erhaltene SMS ist erforderlich.",
        'in'=>"Die ausgewählten Gebote haben eine ungültige SMS erhalten.",
    ], 
    'is_news_notification' => [
        'required' => "Das Feld für die Nachrichtenmeldung ist erforderlich.",
        'in'=>"Die ausgewählte Nachrichtenmeldung ist ungültig.",
    ], 
    'is_marketing_notification' => [
        'required' => "Das Feld ist Marketing-Benachrichtigung ist erforderlich.",
        'in'=>"Die gewählte Marketingmitteilung ist ungültig.",
    ], 
    'is_bids_received_notification' => [
        'required' => "Das Feld ist Gebote erhalten Benachrichtigung ist erforderlich.",
        'in'=>"Die Benachrichtigung über die ausgewählten Gebote ist ungültig.",
    ], 

];
