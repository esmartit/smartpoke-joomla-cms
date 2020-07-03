function sendForm() {
    let t_dateS = $('#timestart').val();
    let t_dateE = $('#timeend').val();
    let t_city = $('#cityId').val();
    let t_spot = $('#selSpot').val();
    let t_sensor = $('#selSensor').val();
    let t_brands = $('#selBrand').val();
    let t_status = $('#selStatus').val();
    let t_ageS = '';
    let t_ageE = '';
    let t_sex = '';
    let t_zipcodes = '';
    let t_member = '';
    if (document.getElementById("checkFilter").checked) {
        t_ageS = $('#from_value').val();
        t_ageE = $('#to_value').val();
        t_sex = $('#selSex').val();
        t_zipcodes = $('#selZipCode').val();
        t_member = $('#selMembership').val();
    }

    let dataForm = { "starttime": t_dateS, "endtime": t_dateE, "city": t_city,
        "spot": t_spot, "sensor": t_sensor, "brands": t_brands,
        "status": t_status, "ageS": t_ageS, "ageE": t_ageE, "gender": t_sex,
        "zipcode": t_zipcodes, "membership": t_member }
}