import React from 'react';

import './InputText.css'
const InputText = ({value, onChange, ...rest}) => (
    <input
        className="todo-input"
        type="text"
        value={value}
        onChange={onChange}
        {...rest}
    />
);

export default InputText;