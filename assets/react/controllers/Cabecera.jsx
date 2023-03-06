import React from 'react';
import PropTypes from 'prop-types';

const Cabecera = (props) => {
    const texto = props.texto;
    return (<h4> {texto} </h4>);
}

Cabecera.propTypes = {
    texto: PropTypes.string.isRequired,
}

Cabecera.defaultProps = {
    texto: 'Precio total: 3$',
}

export default Cabecera;