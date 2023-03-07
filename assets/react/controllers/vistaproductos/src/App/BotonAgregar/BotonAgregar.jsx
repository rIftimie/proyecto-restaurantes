import React, { useState } from 'react';

const BotonAgregar = () => {
    const [quitarVisible, setQuitarVisible] = useState(false);
    const [contador, setContador] = useState(0);

    const handleAgregarClick = () => {
        if (!quitarVisible) {
            setQuitarVisible(true);
        }
        setContador(contador + 1);
    };

    const handleQuitarClick = () => {
        if (contador > 0) {
            setContador(contador - 1);
        }
        if (contador === 1) {
            setQuitarVisible(false);
        }
    };

    return (
        <>
            <button className="botonAgregar" type="button" onClick={handleAgregarClick}>+</button>
            <button className="botonQuitar" type="button" style={{ visibility: quitarVisible ? 'visible' : 'hidden' }} onClick={handleQuitarClick}>-</button>
            <p>Agregados: {contador}</p>
        </>
    );
};

export default BotonAgregar;
