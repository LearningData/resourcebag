    <p><label>School Year: {{ year.value }}</label></p>
    <p>
        <label>Stage:</label>
        {{ text_field("stage", "value":cohort.stage) }}
    </p>
    {{ hidden_field("cohort-id", "value": cohort.id) }}
    <p>
        {{ submit_button("Save") }}
    </p>