import React from 'react';
import classNames from 'classnames';
import './CheckboxCompleted.css'

const CheckboxCompleted = ({name, checked, isDisabled, onClick}) => {
    const doOnClick = isDisabled ? null : onClick
    return (
        <div className="checkbox-competed" onClick={doOnClick}>
            <input name={name} type="checkbox" checked={checked} onChange={() => {}}/>
            <span className={classNames({disabled: isDisabled})} />
        </div>
    )
}

export default CheckboxCompleted;