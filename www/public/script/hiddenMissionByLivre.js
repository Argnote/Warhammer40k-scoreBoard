$(function()
{
    $('.checkBoxLivre').change(function() {
        // console.log(this.id);

        var mission = $('.missions');
        // console.log($('.missions')[1].options[1]);
        for (var m = 0; m < mission.length; m++)
        {
            for (var i = 0; i < mission[m].options.length; i++)
            {
                var element = mission[m].options[i].label.indexOf(this.id)
                if(this.checked)
                {
                    if (element !== -1) {
                        mission[m].options[i].hidden = false;
                    }
                }
                else {
                    if (this.checked === false) {
                        if (element !== -1) {
                            mission[m].options[i].hidden = true;
                        }
                    }
                }
            }
        }
    });
});