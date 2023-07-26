$(document).ready(function () {
    cleaveNpwp();
    cleaveThousand();
    cleaveThousand2Digit();
});

/**
 * Change class cleave-thousand, to accounting format
 * @example 9999.99 to 9,999.99
 */
function cleaveThousand() {
    $(".cleave-thousand")
        .toArray()
        .forEach(function (field) {
            var cleave = new Cleave(field, {
                numeral: true,
                numeralPositiveOnly: true,
                numeralThousandsGroupStyle: "thousand",
                numeralDecimalScale: 30,
            });

            $.valHooks[`#${$(field).attr("id")}`] = {
                getRawValue: function (el) {
                    const result = cleave.getRawValue() == "" ? 0 : parseFloat(cleave.getRawValue());
                    return result;
                },
                setRawValue: function (val) {
                    cleave.setRawValue(parseFloat(val));
                },
            };
        });
}

/**
 * Change class cleave-thousand, to accounting format
 * @example 9999.99 to 9,999.99
 */
function cleaveThousand2Digit() {
    $(".cleave-thousand-2digit")
        .toArray()
        .forEach(function (field) {
            var cleave = new Cleave(field, {
                numeral: true,
                numeralPositiveOnly: true,
                numeralThousandsGroupStyle: "thousand",
                numeralDecimalScale: 2,
            });

            $.valHooks[`#${$(field).attr("id")}`] = {
                getRawValue: function (el) {
                    const result = cleave.getRawValue() == "" ? 0 : parseFloat(cleave.getRawValue());
                    return result;
                },
                setRawValue: function (val) {
                    cleave.setRawValue(parseFloat(val));
                },
            };
        });
}

/**
 * Format NPWP
 * @example
 */
function cleaveNpwp() {
    $(".cleave-npwp")
        .toArray()
        .forEach(function (field) {
            let cleave = new Cleave(field, {
                delimiters: [".", ".", "-", "."],
                blocks: [2, 3, 3, 1, 3, 3],
                uppercase: true,
                onValueChanged: function (id) {
                    let numbers = /^[\.\-0-9]+$/;

                    if (!id.target.rawValue.match(numbers)) {
                        let newValue = id.target.value.replace(/[^\.\-0-9]+/gi, "");
                        $(field).val(newValue);
                    }
                },
            });
        });
}
