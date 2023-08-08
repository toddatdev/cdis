<div class="npdes_permit_authorization">
    <div class="form-group col-md-12">
        @include('layouts.partials.reviewers')
    </div>
    <div class="form-group col-md-12">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="amendments">
                <input type="checkbox"
                       value="Please note that the permit number associated with your approval under the PAG-02 General Permit has been changed to conform to EPA NPDES permit numbering requirements. All future correspondence will reference this new permit application number."
                       id="amendments" name="amendments"> <i class="ml-1"></i> This is a Permit
                Renewal or Amendment </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="coverage">
                <input type="checkbox" name="coverage"
                       value="Persons aggrieved by an action of a conservation district under 25 Pa. Code Chapter 102 may request an informal hearing with DEP within 30 days of publication of this notice in the Pennsylvania Bulletin, pursuant to 25 Pa. Code § 102.32(c). DEP will schedule this informal hearing within 30 days of the request. After this informal hearing, any final determination by DEP may be appealed to the Environmental Hearing Board as provided below."
                       id="coverage"> <i class="ml-1"></i> CCD Approves Coverage </label>
        </div>
    </div>
</div>
