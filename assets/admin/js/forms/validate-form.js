function FormValidation () {
  function fieldHasError (field) {
    for (const error in field.validity) {
      if (field.validity[error] && !field.validity.valid) {
        return error
      }
    }

    return false
  }

  function getCustomMessage (field, errorType) {
    const valueMissing = 'Campo obrigatório'
    const tooShort = `Campo deve ter pelo menos ${field.minLength} caracteres`
    const messages = {
      text: { valueMissing, tooShort },
      email: {
        valueMissing,
        typeMismatch: 'Digite um e-mail válido',
        tooShort
      },
      url: {
        valueMissing,
        typeMismatch: 'Digite uma URL válida',
        tooShort
      },
      'select-one': { valueMissing },
      textarea: { valueMissing },
      password: { valueMissing },
      date: { valueMissing },
      month: { valueMissing },
      checkbox: { valueMissing }
    }
    return messages[field.type][errorType]
  }

  function setFieldRed (field) {
    const element = document.querySelector(field.dataset.errorBorder) || field
    element.classList.add('border-red-600')
  }

  function setFieldDefault (field) {
    const element = document.querySelector(field.dataset.errorBorder) || field
    element.classList.remove('border-red-600')
  }

  function setValidationMessage (field) {
    const hasError = fieldHasError(field)

    if (hasError) {
      const message = getCustomMessage(field, hasError)
      setFieldRed(field)
      setErrorLabelMessage(field, message)
    } else {
      setFieldDefault(field)
      setErrorLabelMessage(field, '')
    }
  }

  function setErrorLabelMessage (field, message) {
    const customErrorLabel = document.querySelector(field.dataset.errorLabel)
    const defaultErrorLabel = field.parentNode.querySelector('label.error-label')
    const errorLabel = customErrorLabel || defaultErrorLabel

    if (errorLabel) {
      errorLabel.innerHTML = message
    }
  }

  function handleInvalidField (event) {
    const field = event.target
    setValidationMessage(field)
  }

  function validateForms () {
    const forms = document.querySelectorAll('form')

    if (!forms) return false

    forms.forEach(form => {
      const fields = form.querySelectorAll('[name]')

      for (const field of fields) {
        field.addEventListener('invalid', (event) => {
          event.preventDefault()
          handleInvalidField(event)
        })
        field.addEventListener('blur', handleInvalidField)
      }
    })
  }

  function start () {
    validateForms()
  }

  return {
    start
  }
}

window.addEventListener('load', () => {
  const formValidation = FormValidation()
  formValidation.start()
})
