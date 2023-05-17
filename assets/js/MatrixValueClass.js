export default class MatrixValueClass {
    alternative = null;
    characteristic = null;
    type = null;
    value = null;
    isMultiple = false;

    constructor(
        alternative,
        characteristic,
        type,
        value,
        isMultiple,
    ) {
        this.alternative = alternative;
        this.characteristic = characteristic;
        this.type = type;
        this.value = value;
        this.isMultiple = isMultiple;
    }
}
