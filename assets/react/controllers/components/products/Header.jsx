import React from 'react';
import PropTypes from 'prop-types';

const Header = (props) => {
    const texto = props.texto;
    return (<h4> {texto} </h4>);
}

Header.propTypes = {
    texto: PropTypes.string.isRequired,
}

Header.defaultProps = {
    texto: 'Precio total: 3$',
}

export default Header;