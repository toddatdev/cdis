<div class="es_permit_technical_deficiency dependent-list-item ">
    <div class="row px-3 ">
        <div class="col-md-9">
            <div class="deficiency-group row">
                <div class="form-group col-md-4 deficiency-item">
                    <label for="deficiencies">Deficiencies</label>
                    <input type="text" id="deficiencies" class="form-control" name="deficiencies[]">
                </div>
            </div>
        </div>
        <div class="form-group col-md-3 mt-4 pt-1">
            <button class="btn btn-primary pull-right" id="btn-add-deficiency">
                Add Deficiency
            </button>
        </div>
    </div>
    <div class="row px-3">
        <div class="form-group col-md-6">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-6">
            <label for="accepted">Application Manager</label>
            <input type="text" class="form-control" name="application_manager">
        </div>
        <div class="form-group col-md-6">
            <label for="accepted">Application Manager Phone</label>
            <input type="text" class="form-control" name="manager_phone">
        </div>
        <div class="form-group col-md-6">
            <label for="accepted">District Mailing Address</label>
            <input type="text" class="form-control" name="district_mailing_address">
        </div>
        <div class="form-group col-md-12">
            <label for="accepted">Regional Mailing Address</label>
            <input type="text" class="form-control" name="regional_mailing_address">
        </div>
        <div class="form-group col-md-12 ">
            <label for="" class="font-weight-bold">PCSM Level</label>
            <div class="i-checks ">
                <label class="checkbox-inline">
                    <input type="radio"
                           value="Please submit 3 copies of the revised E&S plans and 1 copy of the revised PCSM plan to the District at DISTRICT MAILING ADDRESS and the remaining 2 copies of the revised PCSM plan to the Department at DEP REGIONAL OFFICE ADDRESS."
                           name="pcsm_level">
                    <i class="ml-1"></i> Technical Review or Not Delegated
                </label>
                <label class="ml-2"> <input type="radio"
                                            value="Please submit 3 copies of the revised E&S plan and 3 copies of the revised PCSM plans to the District at DISTRICT MAILING ADDRESS.  If you believe that any of the stated deficiencies are not significant, instead of submitting a response to that deficiency, you have the option of requesting that [DEP or the District] to make a permit decision based on the information you have already provided regarding the subject matter of that deficiency.  If you choose this option with regard to any deficiency, you should explain and justify how your current submission satisfies that deficiency.  Please keep in mind that if you fail to respond, your application will be considered withdrawn. "
                                            name="pcsm_level"> <i class="ml-1"></i>
                    Engineering Review</label>
            </div>
        </div>
    </div>
</div>
