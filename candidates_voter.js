function get_votes() {
    var count1 = 0;
    $("button#vote1").on('click', function() {
        window.alert("Vote Submitted.");
        count1 ++;
    });

    var count2 = 0;
    $("button#vote2").on('click', function() {
        window.alert("Vote Submitted.");
        count2 ++;
    });

    var count3 = 0;
    $("button#vote3").on('click', function() {
        window.alert("Vote Submitted.");
        count3 ++;
    });

    var count4 = 0;
    $("button#vote4").on('click', function() {
        window.alert("Vote Submitted.");
        count4 ++;
    });
}