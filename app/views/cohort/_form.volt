    <p><label>School Year: {{ year }}</label></p>
    <p>
        <label>Stage:</label>
        {{ text_field("stage", "value":cohort.stage) }}
    </p>
    {{ hidden_field("cohort-id", "value": cohort.id) }}
    {{ securityTag.csrf(csrf_params) }}
    <p>
        {{ submit_button("Save") }}
    </p>