<div class="recommend_permit_action dependent-list-item ">
    <div class="row px-3">
        <div class="form-group col-md-6">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-6">
            <label for="date">Date when Permit Application Processed</label>
            <input type="text" class="form-control datepicker readonly-date" id="date" readonly
                   name="permit_processed_date">
        </div>
        <div class="form-group col-md-12 ">
            <label for="">Recommended</label>
            <div class="i-checks ">
                <label class="checkbox-inline">
                    <input type="radio" value="yes" name="recommended">
                    <i class="ml-1"></i> Approval
                </label>
                <label class="ml-2"> <input type="radio" value="no" name="recommended"> <i class="ml-1"></i>
                    Denial</label>
            </div>
        </div>
    </div>
</div>
