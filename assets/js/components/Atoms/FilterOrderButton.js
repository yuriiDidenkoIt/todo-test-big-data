import React from 'react';
import classNames from "classnames";

import './FilterOrderButton.css'

const FilterOrderButton = ({ title, isActive, ...rest}) => (
    <div
        className={classNames("filter-btn", {"filter-btn-active": isActive})}
        {...rest}
    >
        { title }
    </div>
)

export default FilterOrderButton;