
// ONLOAD ON HOME
window.onload = function() {

    // CHECK KUNG BUMALIK
    if (performance.navigation.type === performance.navigation.TYPE_BACK_FORWARD) {
        // BALIK SA LOGUT
        window.location.href = 'logout.php';
    }
}
