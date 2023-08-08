<div class="not_partial dependent-list-item ">
    <div class="row px-3">
        <div class="form-group col-md-6">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-6">
            <label for="date">Date of Inspection</label>
            <input type="text" class="form-control datepicker readonly-date" readonly name="inspection_date">
        </div>
        <div class="form-group col-md-12">
            <label for="date">Describe the portion of the site they have identified as terminating the permit</label>
            <textarea name="description" id="da" class="form-control"></textarea>
        </div>
    </div>
</div>
